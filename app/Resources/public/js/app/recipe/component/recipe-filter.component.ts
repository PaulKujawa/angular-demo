import {Component, OnDestroy} from '@angular/core';
import {FilterState} from 'app/shared/service/filter.state';
import {Subscription} from 'rxjs';

@Component({
    selector: 'app-recipe-filter',
    template: `
        <div class="app-recipe-list__filter">
            <mat-form-field class="app-recipe-list-filter__search">
                <input #search
                       matInput
                       (keyup)="setName(search.value)"
                       [placeholder]="'app.common.filter.search'|appTrans">
            </mat-form-field>

            <section class="app-recipe-list-filter__vegan">
                <mat-checkbox #veganOnly
                              (change)="setVegan(veganOnly.checked)">
                    {{ 'app.recipe_list.filter.vegan_only' | appTrans }}
                </mat-checkbox>
            </section>
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
