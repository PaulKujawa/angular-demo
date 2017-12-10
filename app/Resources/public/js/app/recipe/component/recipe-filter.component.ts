import {Component, OnDestroy} from '@angular/core';
import {Subscription} from 'rxjs/Subscription';
import {FilterState} from '../../shared/service/filter.state';

@Component({
    selector: 'recipe-filter',
    template: `
        <div class="row app-filter">
            <div class="col-xs-12 col-sm-6">
                <mat-form-field style="width: 100%">
                    <input #search
                           matInput
                           (keyup)="setName(search.value)"
                           [placeholder]="'app.common.filter.search'|trans">
                </mat-form-field>
            </div>

            <div class="col-xs-2 col-sm-3">
                <section>
                    <mat-checkbox #veganOnly
                                  (change)="setVegan(veganOnly.checked)">
                        {{'app.recipe.filter.vegan_only'|trans}}
                    </mat-checkbox>
                </section>
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
