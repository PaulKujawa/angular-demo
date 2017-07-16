import {Component, Input, OnDestroy, OnInit} from '@angular/core';
import {BehaviorSubject} from 'rxjs/BehaviorSubject';
import {Subject} from 'rxjs/Subject';
import {Subscription} from 'rxjs/Subscription';
import {Pagination} from '../../core/model/pagination';
import {ProductRepository} from '../repository/product.repository';

@Component({
    selector: 'product-filter',
    template: `
        <div class="row app-filter">
            <div class="col-xs-12 col-sm-3">
                <input class="form-control"
                       type="text"
                       placeholder="{{'app.common.filter.search'|trans}}"
                       #search
                       (keyup)="setNameFilter(search.value)"/>
            </div>
            <div class="col-xs-12 col-sm-3">
                <pagination [pagination]="pagination"
                            (clicked)="nextPageFilter($event)"></pagination>
            </div>
        </div>
    `,
})
export class ProductFilterComponent implements OnInit, OnDestroy {
    @Input() public pagination: Pagination;
    private filter = new BehaviorSubject<{[key: string]: string}>({sortName: 'asc'});
    private filterName = new Subject<string>();
    private subscription: Subscription;

    public constructor(private productRepository: ProductRepository) {
    }

    public ngOnInit(): void {
        this.subscription = this.filterName
                                .debounceTime(300)
                                .distinctUntilChanged()
                                .subscribe((name) => {
                                    const filter = this.filter.getValue();
                                    filter.name = name;
                                    filter.page = '1';
                                    this.filter.next(filter);
                                });

        const subscription = this.filter.subscribe((filter) => this.productRepository.getProducts(filter));
        this.subscription.add(subscription);
    }

    public ngOnDestroy(): void {
        this.subscription.unsubscribe();
    }

    public setNameFilter(name: string): void {
        this.filterName.next(name);
    }

    public nextPageFilter(page: number): void {
        this.filter
            .take(1)
            .subscribe((filter) => {
                filter.page = '' + page;
                this.filter.next(filter);
            });
    }
}
