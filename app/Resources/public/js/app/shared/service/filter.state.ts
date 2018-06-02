import {HttpParams} from '@angular/common/http';
import {BehaviorSubject, Observable, Subscription} from 'rxjs';
import {debounceTime, distinctUntilChanged} from 'rxjs/operators';

// TODO rewrite
export class FilterState {
    private filter = new BehaviorSubject<HttpParams>(new HttpParams().set('sortUpdated', 'desc'));
    private buffer: {[key: string]: BehaviorSubject<string>} = {};
    private readonly pageKey = 'page';

    public getFilter(): Observable<HttpParams> {
        return this.filter.asObservable();
    }

    public setParam(param: string, value: string): void {
        let params = this.filter.getValue();

        if (params.get(param) === value) {
            return;
        }

        if (param !== this.pageKey) {
            params = params.set('page', '1');
        }

        params = value
            ? params.set(param, value)
            : params.delete(param);

        this.filter.next(params);
    }

    public setDebouncedProperty(param: string, value: string): Subscription | undefined {
        if (param in this.buffer) {
            this.buffer[param].next(value);

            return;
        }

        this.buffer[param] = new BehaviorSubject<string>(value);

        return this.buffer[param]
            .pipe(
                debounceTime(300),
                distinctUntilChanged(),
            )
            .subscribe((finalValue) => this.setParam(param, finalValue));
    }
}
