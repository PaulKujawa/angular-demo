import {Component, EventEmitter, Input, OnDestroy, OnInit, Output} from '@angular/core';
import {Subscription} from 'rxjs/Subscription';
import {Pagination} from '../../core/model/pagination';
import {FilterParameter, FilterService} from '../../shared/service/filter.service';

@Component({
    selector: 'recipe-filter',
    providers: [FilterService],
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
    @Output('filter') public eventEmitter = new EventEmitter<FilterParameter>();
    private subscription: Subscription;

    public constructor(public filterService: FilterService) {
    }

    public ngOnInit(): void {
        this.subscription = this.filterService.filter.subscribe(this.eventEmitter);
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

    public setVegan(checked: boolean): void {
        this.filterService.set('vegan', checked ? 'true' : '');
    }

    public setPage(page: number): void {
        this.filterService.set('page', String(page));
    }
}
