import {Component, OnDestroy, OnInit} from '@angular/core';
import {Observable} from 'rxjs/Observable';
import {Subscription} from 'rxjs/Subscription';
import {Pageable} from '../../core/model/pageable';
import {FilterState} from '../../shared/service/filter.state';
import {Product} from '../model/product';
import {ProductState} from '../service/product.state';

@Component({
    selector: 'product-filter',
    template: `
        <div class="row app-filter">
            <div class="col-xs-7 col-sm-3">
                <input class="form-control"
                       type="text"
                       placeholder="{{'app.common.filter.search'|trans}}"
                       #search
                       (keyup)="setName(search.value)"/>
            </div>
            <div class="col-xs-5 col-sm-3">
                <pagination class="pull-right"
                            [pagination]="(pageable|async)?.pagination"
                            (clicked)="setPage($event)">
                </pagination>
            </div>
        </div>
    `,
})
export class ProductFilterComponent implements OnInit, OnDestroy {
    public pageable: Observable<Pageable<Product>>;
    private subscription?: Subscription;

    public constructor(private productState: ProductState,
                       private filterState: FilterState) {
    }

    public ngOnInit(): void {
        this.pageable = this.productState.getProducts();
    }

    public ngOnDestroy(): void {
        this.subscription && this.subscription.unsubscribe();
    }

    public setName(name: string): void {
        this.subscription = this.filterState.setDebouncedProperty('name', name);
    }

    public setPage(page: number): void {
        this.filterState.setParam('page', String(page));
    }
}
