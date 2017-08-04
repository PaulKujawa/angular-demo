import {Component, Input, OnDestroy, OnInit} from '@angular/core';
import {Subscription} from 'rxjs/Subscription';
import {Pagination} from '../../core/model/pagination';
import {FilterService} from '../../shared/service/filter.service';
import {ProductRepository} from '../repository/product.repository';

@Component({
    selector: 'product-filter',
    providers: [FilterService],
    template: `
        <div class="row app-filter">
            <div class="col-xs-12 col-sm-3">
                <input class="form-control"
                       type="text"
                       placeholder="{{'app.common.filter.search'|trans}}"
                       #search
                       (keyup)="setName(search.value)"/>
            </div>
            <div class="col-xs-12 col-sm-3">
                <pagination [pagination]="pagination"
                            (clicked)="setPage($event)"></pagination>
            </div>
        </div>
    `,
})
export class ProductFilterComponent implements OnInit, OnDestroy {
    @Input() public pagination: Pagination;
    private subscription: Subscription;

    public constructor(private productRepository: ProductRepository,
                       private filterService: FilterService) {
    }

    public ngOnInit(): void {
        this.subscription = this.filterService.filter.subscribe((filter) => this.productRepository.getProducts(filter));
    }

    public ngOnDestroy(): void {
        this.subscription.unsubscribe();
    }

    public setName(name: string): void {
        const subscription = this.filterService.setDebounced('name', name);

        if (subscription) {
            this.subscription.add(subscription);
        }
    }

    public setPage(page: number): void {
        this.filterService.set('page', String(page));
    }
}
