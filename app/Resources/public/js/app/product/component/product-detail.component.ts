import {Component, HostBinding, OnInit} from '@angular/core';
import {ActivatedRoute, Params} from '@angular/router';
import {slideInDownAnimation} from '../../core/animations';
import {ProductResponseDto} from '../model/dto/product-response.dto';
import {Product} from '../model/product';
import {ProductRepository} from '../repository/product.repository';

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
    public product: Product;

    constructor(private productRepository: ProductRepository,
                private route: ActivatedRoute) {
    }

    public ngOnInit(): void {
        this.route.params
            .do(() => {
                this.product = new Product({} as ProductResponseDto);
            })
            .filter((params: Params) => !isNaN(params.id))
            .switchMap((params: Params) => this.productRepository.getProduct(params.id))
            .subscribe((product: Product) => this.product = product);
    }
}
