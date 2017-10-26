import {Component, HostBinding, OnInit} from '@angular/core';
import {ActivatedRoute} from '@angular/router';
import {slideInDownAnimation} from '../../core/animations';
import {Product} from '../model/product';
import {ProductState} from '../service/product.state';

@Component({
    animations: [slideInDownAnimation],
    template: `
        <product-form [product]="product"></product-form>
    `,
})
export class ProductDetailComponent implements OnInit {
    @HostBinding('@routeAnimation') public routeAnimation = true;
    @HostBinding('style.display') public display = 'block';
    @HostBinding('style.position') public position = 'absolute';
    public product?: Product;

    constructor(private productState: ProductState,
                private route: ActivatedRoute) {
    }

    public ngOnInit(): void {
        this.route.params
            .do(() => this.product = undefined)
            .filter((params) => !isNaN(params.id))
            .switchMap((params) => this.productState.getProduct(+params.id))
            .subscribe((product) => this.product = product);
    }
}
