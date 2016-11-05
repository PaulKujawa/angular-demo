import {Component, OnInit, Output, EventEmitter} from '@angular/core';
import {Observable} from 'rxjs/Observable';
import {Subject} from "rxjs/Subject";

@Component({
    selector: 'filter',
    template: `
        <div>
            <input class="form-control" type="text" placeholder="{{'app.recipe.filter.search'|trans}}" 
            #search (keyup)="searchNext(search.value)"/>
            <div class="checkbox">
                <label>
                    <input type="checkbox" #veganOnly (change)="setVeganOnly(veganOnly.checked)">
                    {{'app.recipe.filter.vegan_only'|trans}}
                </label>
            </div>
        </div>
    `
})
export class FilterComponent implements OnInit {
    @Output('filter') eventEmitter: EventEmitter<Map<string, string>> = new EventEmitter();
    private filterMap = new Map<string, string>();
    private searchStream = new Subject<string>();

    ngOnInit(): void {
        this.initializeSearchStream();
    }

    searchNext(name: string): void {
        this.searchStream.next(name);
    }

    setVeganOnly(checked: boolean): void {
        checked ? this.filterMap.set('vegan', 'true') : this.filterMap.delete('vegan');
        this.eventEmitter.emit(this.filterMap);
    }

    private initializeSearchStream(): void {
        const preLoad = Observable.of('');
        const searchStream = this.searchStream
            .debounceTime(300)
            .distinctUntilChanged();

        Observable.merge(preLoad, searchStream)
            .subscribe((search: string) => {
                search ? this.filterMap.set('name', search) : this.filterMap.delete('name');
                this.eventEmitter.emit(this.filterMap);
            });
    }
}
