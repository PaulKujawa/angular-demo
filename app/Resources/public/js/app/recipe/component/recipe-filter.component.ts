import {HttpParams} from '@angular/common/http';
import {Component, EventEmitter, Input, OnDestroy, OnInit, Output} from '@angular/core';
import {Subscription} from 'rxjs/Subscription';
import {Pagination} from '../../core/model/pagination';
import {FilterState} from '../../shared/service/filter.state';

@Component({
    selector: 'recipe-filter',
    providers: [FilterState],
    template: `
        <div class="row app-filter">
            <div class="col-xs-12 col-sm-4">
                <input class="form-control"
                       type="text"
                       placeholder="{{'app.common.filter.search'|trans}}"
                       #search
                       (keyup)="setName(search.value)"/>
            </div>
            <div class="col-xs-12 col-sm-3">
                <div class="checkbox">
                    <label>
                        <input type="checkbox"
                               #veganOnly
                               (change)="setVegan(veganOnly.checked)">
                        {{'app.recipe.filter.vegan_only' | trans}}
                    </label>
                </div>
            </div>
            <div class="col-xs-12 col-sm-5">
                <pagination [pagination]="pagination"
                            (clicked)="setPage($event)"></pagination>
            </div>
        </div>
    `,
})
export class RecipeFilterComponent implements OnInit, OnDestroy {
    @Input() public pagination: Pagination;
    @Output('filter') public eventEmitter = new EventEmitter<HttpParams>();
    private subscription: Subscription;

    public constructor(private filterState: FilterState) {
    }

    public ngOnInit(): void {
        this.subscription = this.filterState.getFilter()
            .subscribe(this.eventEmitter);
    }

    public ngOnDestroy(): void {
        this.subscription.unsubscribe();
    }

    public setName(name: string): void {
        const subscription = this.filterState.setDebouncedProperty('name', name);

        if (subscription) {
            this.subscription.add(subscription);
        }
    }

    public setVegan(checked: boolean): void {
        this.filterState.setParam('vegan', checked ? 'true' : '');
    }

    public setPage(page: number): void {
        this.filterState.setParam('page', String(page));
    }
}
