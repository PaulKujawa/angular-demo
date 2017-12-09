import {Component, OnDestroy} from '@angular/core';
import {Subscription} from 'rxjs/Subscription';
import {FilterState} from '../../shared/service/filter.state';

@Component({
    selector: 'product-filter',
    template: `
        <div class="app-product-filter">
            <input #search
                   [placeholder]="'app.common.filter.search'|trans"
                   (keyup)="setName(search.value)"
                   class="form-control"
                   type="text">
        </div>
    `,
})
export class ProductFilterComponent implements OnDestroy {
    private subscription?: Subscription;

    public constructor(private filterState: FilterState) {
    }

    public ngOnDestroy(): void {
        this.subscription && this.subscription.unsubscribe();
    }

    public setName(name: string): void {
        const subscription = this.filterState.setDebouncedProperty('name', name);

        if (!subscription) {
            return;
        }

        if (!this.subscription) {
            this.subscription = subscription;
        }

        this.subscription.add(this.subscription);
    }
}
