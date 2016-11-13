import {Pagination} from "./pagination";

export class PageableInterface<T> {
    pagination: Pagination;
    docs: Array<T>;
}
