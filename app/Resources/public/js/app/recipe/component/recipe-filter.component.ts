import {Component, OnDestroy} from '@angular/core';
import {Subscription} from 'rxjs/Subscription';
import {FilterState} from '../../shared/service/filter.state';

@Component({
    selector: 'recipe-filter',
    template: `
        <div class="row app-filter">
            <div class="col-xs-5 col-sm-6">
                <input #search
                       [placeholder]="'app.common.filter.search'|trans"
                       (keyup)="setName(search.value)"
                       type="text"
                       class="form-control">
            </div>

            <div class="col-xs-2 col-sm-3">
                <div class="checkbox">
                    <label>
                        <input #veganOnly
                               (change)="setVegan(veganOnly.checked)"
                               type="checkbox">
                        {{'app.recipe.filter.vegan_only' | trans}}
                    </label>
                </div>
            </div>
        </div>
    `,
})
export class RecipeFilterComponent implements OnDestroy {
    private subscription = new Subscription();

    public constructor(private filterState: FilterState) {
    }

    public ngOnDestroy(): void {
        this.subscription.unsubscribe();
    }

    public setName(name: string): void {
        const subscription = this.filterState.setDebouncedProperty('name', name);

        this.subscription.add(subscription);
    }

    public setVegan(checked: boolean): void {
        this.filterState.setParam('vegan', checked ? 'true' : '');
    }
}
