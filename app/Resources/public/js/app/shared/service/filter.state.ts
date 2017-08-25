import {HttpParams} from '@angular/common/http';
import {BehaviorSubject} from 'rxjs/BehaviorSubject';
import {Observable} from 'rxjs/Observable';
import {Subscription} from 'rxjs/Subscription';

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
            .debounceTime(300)
            .distinctUntilChanged()
            .subscribe((finalValue) => this.setParam(param, finalValue));
    }
}
