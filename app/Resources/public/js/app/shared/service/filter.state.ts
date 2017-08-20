import {BehaviorSubject} from 'rxjs/BehaviorSubject';
import {Observable} from 'rxjs/Observable';
import {Subscription} from 'rxjs/Subscription';

export interface FilterParameter {
    [key: string]: string;
}

export class FilterState {
    private filter = new BehaviorSubject<FilterParameter>({sortUpdated: 'desc'});
    private debounced: {[key: string]: BehaviorSubject<string>} = {};
    private readonly pageKey = 'page';

    public getFilter(): Observable<FilterParameter> {
        return this.filter.asObservable();
    }

    public setProperty(key: string, value: string): void {
        const filter = this.filter.getValue();

        if (filter[key] === value) {
            return;
        }

        if (key !== this.pageKey) {
            filter.page = '1';
        }

        value
            ? filter[key] = value
            : delete filter[key];

        this.filter.next(filter);
    }

    public setDebouncedProperty(key: string, value: string): Subscription | undefined {
        if (key in this.debounced) {
            this.debounced[key].next(value);

            return;
        }

        this.debounced[key] = new BehaviorSubject<string>(value);

        return this.debounced[key]
            .debounceTime(300)
            .distinctUntilChanged()
            .subscribe((finalValue) => this.setProperty(key, finalValue));
    }
}
