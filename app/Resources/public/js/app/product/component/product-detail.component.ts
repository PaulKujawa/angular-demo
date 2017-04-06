import {Component, OnInit, HostBinding} from '@angular/core';
import {ActivatedRoute, Params} from '@angular/router';
import {FlashMessageService} from '../../core/service/flash-message.service';
import {FlashMessage} from '../../core/model/flash-message';
import {slideInDownAnimation} from '../../core/animations';
import {ProductRepository} from '../repository/product.repository';
import {Product} from '../model/product';
import {ProductResponseDto} from '../model/dto/product-response.dto';

@Component({
    animations: [slideInDownAnimation],
    template: `
        <product-form [product]="product" [isEditMode]="isEditMode"></product-form>
    `
})
export class ProductDetailComponent implements OnInit {
    @HostBinding('@routeAnimation') routeAnimation = true;
    @HostBinding('style.display') display = 'block';
    @HostBinding('style.position') position = 'absolute';
    product: Product;
    isEditMode = false;

    constructor(private productRepository: ProductRepository,
                private route: ActivatedRoute,
                private flashMsgService: FlashMessageService) {}

    ngOnInit(): void {
        this.route.params
            .do(nil => {
                this.product = new Product({} as ProductResponseDto);
                this.isEditMode = false;
            })
            .filter((params: Params) => !isNaN(params.id))
            .switchMap((params: Params) => this.productRepository.getProduct(params.id))
            .subscribe(
                (product: Product) => {
                    this.product = product;
                    this.isEditMode = true;
                },
                (error: string) => this.flashMsgService.push(new FlashMessage('danger', error))
            );
    }
}
