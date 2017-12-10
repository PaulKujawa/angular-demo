import {Component} from '@angular/core';
import {Router} from '@angular/router';
import {Product} from '../model/product';
import {ProductState} from '../service/product.state';

@Component({
    template: `
        <div class="row">
            <div class="col-xs-8 col-sm-4 col-md-3">
                <product-filter></product-filter>
            </div>

            <div class="col-xs-4 col-sm-2 col-md-1">
                <button mat-raised-button
                        color="accent"
                        (click)="onAddProduct()"
                        class="app-product__create">
                    {{'app.common.new' | trans}}
                </button>
            </div>
        </div>

        <div *ngIf="productState.getPageable()|async as products"
             class="row">
            <div class="col-xs-12 col-sm-6 col-md-4">
                <mat-nav-list>
                    <a *ngFor="let product of products.docs"
                       mat-list-item
                       (click)="onSelectProduct(product)">
                        {{product.name}}
                    </a>
                </mat-nav-list>

                <pagination></pagination>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-8">
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
