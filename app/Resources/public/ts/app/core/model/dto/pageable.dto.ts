import {Pagination} from '../../../shared/model/pagination';

export class PageableDto<T> {
    docs: T[];
    pagination: Pagination;
}
