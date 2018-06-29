import {Component, OnInit} from '@angular/core';
import {Pagination} from 'app/core/model/pagination';
import {PageableState} from 'app/shared/model/pageable.state';
import {FilterState} from 'app/shared/service/filter.state';
import {Observable} from 'rxjs';
import {map} from 'rxjs/operators';

interface MatPaginatorEvent {
    pageIndex: number;
    pageSize: number;
    length: number;
}

@Component({
    selector: 'app-pagination',
    template: `
        <mat-paginator *ngIf="paginationStream|async as pagination"
                       [pageIndex]="pagination.page - 1"
                       [pageSize]="pagination.pageSize"
                       [length]="pagination.numFound"
                       [hidePageSize]="true"
                       (page)="onClick($event)">
        </mat-paginator>
    `,
})
export class PaginationComponent implements OnInit {
    public paginationStream: Observable<Pagination>;

    public constructor(private pageableState: PageableState,
                       private filterState: FilterState) {
    }

    public ngOnInit(): void {
        this.paginationStream = this.pageableState.getPageable()
            .pipe(
                map((pageable) => pageable.pagination),
            );
    }

    public onClick({pageIndex}: MatPaginatorEvent): void {
        this.filterState.setParam('page', String(++pageIndex));
    }
}
