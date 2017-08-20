import {Component, EventEmitter, Input, Output} from '@angular/core';
import {Pagination} from '../../core/model/pagination';

@Component({
    selector: 'pagination',
    template: `
        <nav class="app-filter__nav"
             *ngIf="pagination?.pages > 1">
            <ul class="pagination app-filter__pagination">
                <li [class.disabled]="isFirstPage()">
                    <a class="btn"
                       [class.disabled]="isFirstPage()"
                       (click)="onClick(pagination.page - 1)">
                        <span>&laquo;</span></a>
                </li>
                <li [class.disabled]="isFirstPage()">
                    <a class="btn"
                       [class.disabled]="isFirstPage()"
                       (click)="onClick(1)">1</a>
                </li>
                <li class="disabled">
                    <a class="btn disabled">..</a>
                </li>

                <li class="active">
                    <a>{{pagination.page}}</a>
                </li>

                <li class="disabled">
                    <a class="btn disabled">..</a>
                </li>
                <li [class.disabled]="isLastPage()">
                    <a class="btn"
                       [class.disabled]="isLastPage()"
                       (click)="onClick(pagination.pages)">
                        {{pagination.pages}}
                    </a>
                </li>
                <li [class.disabled]="isLastPage()">
                    <a class="btn"
                       [class.disabled]="isLastPage()"
                       (click)="onClick(pagination.page + 1)">
                        <span>&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    `,
})
export class PaginationComponent {
    @Input() public pagination?: Pagination;
    @Output('clicked') public eventEmitter = new EventEmitter<number>();

    public onClick(page: number): void {
        this.eventEmitter.emit(page);
    }

    public isFirstPage(): boolean {
        return !!this.pagination && this.pagination.page === 1;
    }

    public isLastPage(): boolean {
        return !!this.pagination && this.pagination.page === this.pagination.pages;
    }
}
