import {Component, OnInit, HostBinding} from '@angular/core';
import {ActivatedRoute, Params} from '@angular/router';
import {FlashMessageService} from '../../core/service/flash-message.service';
import {FlashMessage} from '../../core/model/flash-message';
import {slideInDownAnimation} from '../../core/animations';
import {ProductRepository} from '../repository/product.repository';
import {Product} from '../model/product';

@Component({
    animations: [slideInDownAnimation],
    template: `
        <product-form [product]="product"></product-form>
    `
})
export class ProductDetailComponent implements OnInit {
    @HostBinding('@routeAnimation') routeAnimation = true;
    @HostBinding('style.display') display = 'block';
    @HostBinding('style.position') position = 'absolute';
    product: Product;

    constructor(private productRepository: ProductRepository,
                private activatedRoute: ActivatedRoute,
                private flashMsgService: FlashMessageService) {}

    ngOnInit(): void {
        this.activatedRoute.params
            .switchMap((params: Params) => this.productRepository.getProduct(+params['id']))
            .subscribe(
                (product: Product) => this.product = product,
                (error: string) => this.flashMsgService.push(new FlashMessage('danger', error))
            );
    }
}
