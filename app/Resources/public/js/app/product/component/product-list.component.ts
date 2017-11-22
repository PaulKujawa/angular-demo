import {Component} from '@angular/core';
import {Router} from '@angular/router';
import {Product} from '../model/product';
import {ProductState} from '../service/product.state';

@Component({
    template: `
        <product-filter></product-filter>

        <div class="row" *ngIf="productState.getProducts()|async as products">
            <div class="col-xs-12 col-sm-6">
                <ul class="list-group">
                    <li class="list-group-item app-products__item"
                        (click)="onSelectProduct(product)"
                        *ngFor="let product of products.docs">
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
export class ProductListComponent {
    constructor(public productState: ProductState,
                private router: Router) {
    }

    public onAddProduct(): void {
        this.router.navigate(['products/new']);
    }

    public onSelectProduct(product: Product): void {
        const productName = product.name.replace(' ', '-');
        this.router.navigate(['products', product.id, productName]);
    }
}
