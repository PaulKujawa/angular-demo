import {Component, OnInit} from '@angular/core';
import {Router} from '@angular/router';
import {Subject} from 'rxjs/Subject';
import {ProductRepository} from '../repository/product.repository';
import {Product} from '../model/product';
import {FlashMessageService} from '../../core/service/flash-message.service';
import {FlashMessage} from '../../core/model/flash-message';
import {Products} from '../model/products';

@Component({
    template: `
        <div class="row">
            <div class="col-xs-12">
                <product-filter [pagination]="products?.pagination" (filter)="onFilter($event)"></product-filter>
            </div>
        </div>
        
         <ul class="list-group">
            <li class="list-group-item app-products__item" (click)="onSelectProduct(product)" *ngFor="let product of products?.docs">
                {{product.name}}
            </li>
        </ul>
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
            .switchMap((queryParams: Map<string, string>) => this.productRepository.getProducts(queryParams))
            .subscribe(
                (products: Products) => this.products = products,
                (error: string) => this.flashMsgService.push(new FlashMessage('danger', error))
            );
    }

    onFilter(filterMap: Map<string, string>): void {
        this.filterStream.next(filterMap);
    }

    onSelectProduct(product: Product): void {
        this.router.navigate(['/products', product.id, product.name]); // TODO escape spaces in name
    }
}
