import {Component, OnInit} from '@angular/core';
import {Router} from '@angular/router';
import {Subject} from 'rxjs/Subject';
import {FlashMessageService} from '../../core/service/flash-message.service';
import {FlashMessage} from '../../core/model/flash-message';
import {ProductRepository} from '../repository/product.repository';
import {Product} from '../model/product';
import {Products} from '../model/products';
import {Observable} from 'rxjs';

@Component({
    template: `
        <product-filter [pagination]="products?.pagination" (filter)="onFilter($event)"></product-filter>
                        
        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <ul class="list-group">
                    <li class="list-group-item app-products__item" (click)="onSelectProduct(product)" *ngFor="let product of products?.docs">
                        {{product.name}}
                    </li>
                </ul>
            </div>
            <div class="col-xs-12 col-sm-6">
                <router-outlet></router-outlet>
            </div>
        </div>
    `
})
export class ProductListComponent implements OnInit {
    products: Products;
    private filterStream = new Subject<Map<string, string>>();

    constructor(private router: Router,
                private flashMsgService: FlashMessageService,
                private productRepository: ProductRepository) {}

    ngOnInit(): void {
        this.filterStream
            .subscribe((queryParams: Map<string, string>) => this.productRepository.reloadProducts(queryParams));

        this.productRepository.products
            .subscribe(
                (products: Products) => this.products = products,
                (error: string) => this.flashMsgService.push(new FlashMessage('danger', error))
            );
    }

    onFilter(filterMap: Map<string, string>): void {
        this.filterStream.next(filterMap);
    }

    onSelectProduct(product: Product): void {
        const productName = product.name.replace(' ', '-');
        this.router.navigate(['products', product.id, productName]);
    }
}
