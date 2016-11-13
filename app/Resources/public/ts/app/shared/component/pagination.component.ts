import {Component, Input, Output, EventEmitter} from '@angular/core';
import {Pagination} from "../model/pagination";

@Component({
    selector: 'pagination',
    template: `
        <nav *ngIf="pagination?.pages > 1">
            <ul class="pagination">
                <li [class.disabled]="isFirstPage()">
                    <a class="btn" [class.disabled]="isFirstPage()" (click)="onClick(pagination.page - 1)">
                    <span>&laquo;</span></a>
                </li>
                <li [class.disabled]="isFirstPage()">
                    <a class="btn" [class.disabled]="isFirstPage()" (click)="onClick(1)">1</a>
                </li>
                <li class="disabled"><a class="btn disabled">..</a></li>
                
                <li class="active">
                    <a>{{pagination.page}}</a>
                </li>
                
                <li class="disabled"><a class="btn disabled">..</a></li>
                <li [class.disabled]="isLastPage()">
                    <a class="btn" [class.disabled]="isLastPage()" (click)="onClick(pagination.pages)">{{pagination.pages}}</a>
                </li>
                <li [class.disabled]="isLastPage()">
                    <a  class="btn" [class.disabled]="isLastPage()" (click)="onClick(pagination.page + 1)">
                        <span>&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    `
})
export class PaginationComponent {
    @Input() pagination: Pagination;
    @Output('clicked') eventEmitter: EventEmitter<number> = new EventEmitter();

    onClick(page: number): void {
        this.eventEmitter.emit(page);
    }

    isFirstPage(): boolean {
        return this.pagination && this.pagination.page === 1;
    }

    isLastPage(): boolean {
        return this.pagination && this.pagination.page === this.pagination.pages;
    }
}
