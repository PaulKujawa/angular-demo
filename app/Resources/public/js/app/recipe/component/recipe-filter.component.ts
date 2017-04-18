import {Component, EventEmitter, Input, OnInit, Output} from '@angular/core';
import {Observable} from 'rxjs/Observable';
import {Subject} from 'rxjs/Subject';
import {Pagination} from '../../core/model/pagination';

@Component({
    selector: 'recipe-filter',
    template: `
        <div class="row app-filter">
            <div class="col-xs-12 col-sm-4">
                <input class="form-control" type="text" placeholder="{{'app.common.filter.search'|trans}}"
                #search (keyup)="searchNext(search.value)"/>
            </div>
            <div class="col-xs-12 col-sm-3">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" #veganOnly (change)="setVeganOnly(veganOnly.checked)">
                        {{'app.recipe.filter.vegan_only'|trans}}
                    </label>
                </div>
            </div>
            <div class="col-xs-12 col-sm-5">
                <pagination [pagination]="pagination" (clicked)="setPage($event)"></pagination>
            </div>
        </div>
    `,
})
export class RecipeFilterComponent implements OnInit {
    @Input() public pagination: Pagination;
    @Output('filter') public eventEmitter: EventEmitter<Map<string, string>> = new EventEmitter();
    private filterMap = new Map<string, string>();
    private searchStream = new Subject<string>();

    public ngOnInit(): void {
        this.filterMap.set('sortUpdated', 'desc');
        this.initializeSearchStream();
    }

    public searchNext(name: string): void {
        this.searchStream.next(name);
    }

    public setVeganOnly(checked: boolean): void {
        checked ? this.filterMap.set('vegan', 'true') : this.filterMap.delete('vegan');
        this.filterMap.set('page', '1');
        this.eventEmitter.emit(this.filterMap);
    }

    public setPage(page: number): void {
        this.filterMap.set('page', '' + page);
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
                this.filterMap.set('page', '1');
                this.eventEmitter.emit(this.filterMap);
            });
    }
}
