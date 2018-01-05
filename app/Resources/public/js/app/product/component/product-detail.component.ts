import {Component, HostBinding, OnInit} from '@angular/core';
import {ActivatedRoute} from '@angular/router';
import {Observable} from 'rxjs/Observable';
import {slideInDownAnimation} from '../../core/animations';
import {Product} from '../model/product';
import {ProductState} from '../service/product.state';

@Component({
    animations: [slideInDownAnimation],
    template: `
        <app-product-form [product]="product|async">
        </app-product-form>
    `,
})
export class ProductDetailComponent implements OnInit {
    @HostBinding('@routeAnimation') public routeAnimation = true;
    @HostBinding('style.display') public display = 'block';
    @HostBinding('style.position') public position = 'absolute';
    public product: Observable<Product | undefined>;

    constructor(private productState: ProductState,
                private activatedRoute: ActivatedRoute) {
    }

    public ngOnInit(): void {
        this.product = this.activatedRoute.params
            .switchMap((params) => {
                return !isNaN(params.id)
                    ? this.productState.getProduct(+params.id)
                    : Observable.of(undefined);
            });
    }
}
