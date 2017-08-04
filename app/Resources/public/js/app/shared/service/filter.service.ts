import {BehaviorSubject} from 'rxjs/BehaviorSubject';
import {Subscription} from 'rxjs/Subscription';

export interface FilterParameter {
    [key: string]: string;
}

export class FilterService {
    public filter = new BehaviorSubject<FilterParameter>({sortUpdated: 'desc'});
    private debounced: {[key: string]: BehaviorSubject<string>} = {};
    private readonly pageKey = 'page';

    public set(key: string, value: string): void {
        const filter = this.filter.getValue();
        value ? filter[key] = value : delete filter[key];

        if (key !== this.pageKey) {
            filter.page = '1';
        }

        this.filter.next(filter);
    }

    public setDebounced(key: string, value: string): Subscription | void {
        if (key in this.debounced) {
            this.debounced[key].next(value);

            return;
        }

        this.debounced[key] = new BehaviorSubject<string>(value);

        return this.debounced[key].debounceTime(300)
                                  .distinctUntilChanged()
                                  .subscribe((finalValue) => this.set(key, finalValue));
    }
}
