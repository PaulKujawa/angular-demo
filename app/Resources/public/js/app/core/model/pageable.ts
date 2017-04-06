import {Pagination} from './pagination';

/**
 * @see PageableFactory
 */
export class Pageable<T> {
    constructor(public pagination: Pagination,
                public docs: T[]) {
    }
}
