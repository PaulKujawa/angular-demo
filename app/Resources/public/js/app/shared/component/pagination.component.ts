import {Component, OnInit} from '@angular/core';
import {Observable} from 'rxjs/Observable';
import {Pagination} from '../../core/model/pagination';
import {PageableState} from '../model/pageable.state';
import {FilterState} from '../service/filter.state';

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
        this.paginationStream = this.pageableState
            .getPageable()
            .map((pageable) => pageable.pagination);
    }

    public onClick({pageIndex}: MatPaginatorEvent): void {
        this.filterState.setParam('page', String(++pageIndex));
    }
}
