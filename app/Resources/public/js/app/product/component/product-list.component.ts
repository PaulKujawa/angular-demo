import {Component, OnDestroy, OnInit} from '@angular/core';
import {Router} from '@angular/router';
import {Observable} from 'rxjs/Observable';
import {Subject} from 'rxjs/Subject';
import {Subscription} from 'rxjs/Subscription';
import {Pageable} from '../../core/model/pageable';
import {Product} from '../model/product';
import {ProductRepository} from '../repository/product.repository';
import {ProductState} from '../service/product.state';

@Component({
    template: `
        <product-filter [pagination]="(pageable|async)?.pagination"
                        (filter)="onFilter($event)">
        </product-filter>

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
                    {{'app.common.new'|trans}}
                </button>
            </div>
            <div class="col-xs-12 col-sm-6">
                <router-outlet></router-outlet>
            </div>
        </div>
    `,
})
export class ProductListComponent implements OnInit, OnDestroy {
    public pageable: Observable<Pageable<Product>>;
    private filterStream = new Subject<Map<string, string>>();
    private subscription: Subscription;

    constructor(private router: Router,
                private productRepository: ProductRepository,
                private productState: ProductState) {
    }

    public ngOnInit(): void {
        this.pageable = this.productState.pageable;

        this.subscription = this.filterStream.subscribe((queryParams: Map<string, string>) => {
            this.productRepository.getProducts(queryParams);
        });
    }

    public ngOnDestroy(): void {
        this.subscription.unsubscribe();
    }

    public onAddProduct(): void {
        this.router.navigate(['products/new']);
    }

    public onFilter(filterMap: Map<string, string>): void {
        this.filterStream.next(filterMap);
    }

    public onSelectProduct(product: Product): void {
        const productName = product.name.replace(' ', '-');
        this.router.navigate(['products', product.id, productName]);
    }
}
