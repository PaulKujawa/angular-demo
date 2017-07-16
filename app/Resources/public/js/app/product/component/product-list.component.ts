import {Component, OnInit} from '@angular/core';
import {Router} from '@angular/router';
import {Observable} from 'rxjs/Observable';
import {Pageable} from '../../core/model/pageable';
import {Product} from '../model/product';
import {ProductState} from '../service/product.state';

@Component({
    template: `
        <product-filter [pagination]="(pageable|async)?.pagination"></product-filter>

        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <ul class="list-group">
                    <li class="list-group-item app-products__item"
                        (click)="onSelectProduct(product)"
                        *ngFor="let product of (pageable|async)?.docs">
                        {{product.name}}
                    </li>
                </ul>
                <button type="button"
                        class="btn btn-primary"
                        (click)="onAddProduct()">
                    {{'app.common.new' | trans}}
                </button>
            </div>
            <div class="col-xs-12 col-sm-6">
                <router-outlet></router-outlet>
            </div>
        </div>
    `,
})
export class ProductListComponent implements OnInit {
    public pageable: Observable<Pageable<Product>>;

    constructor(private router: Router,
                private productState: ProductState) {
    }

    public ngOnInit(): void {
        this.pageable = this.productState.pageable;
    }

    public onAddProduct(): void {
        this.router.navigate(['products/new']);
    }

    public onSelectProduct(product: Product): void {
        const productName = product.name.replace(' ', '-');
        this.router.navigate(['products', product.id, productName]);
    }
}
