import {Component} from '@angular/core';
import {Router} from '@angular/router';
import {Product} from '../model/product';
import {ProductState} from '../service/product.state';

@Component({
    template: `
        <div class="app-product-list">
            <div class="app-product-list__filter">
                <button mat-raised-button
                        color="accent"
                        (click)="onAddProduct()"
                        class="app-product-list-filter__create">
                    {{ 'app.common.new'|appTrans }}
                </button>

                <app-product-filter></app-product-filter>
            </div>

            <mat-nav-list *ngIf="productState.getPageable()|async as products"
                          class="app-product-list">
                <a *ngFor="let product of products.docs"
                   mat-list-item
                   (click)="onSelectProduct(product)">
                    {{ product.name }}
                </a>
            </mat-nav-list>

            <app-pagination></app-pagination>

            <div class="app-product-list__outlet">
                <router-outlet>
                </router-outlet>
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
