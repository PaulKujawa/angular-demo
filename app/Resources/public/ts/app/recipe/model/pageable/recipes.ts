import {PageableInterface} from "../../../shared/model/pageable-interface";
import {Pagination} from "../../../shared/model/pagination";
import {Recipe} from "../recipe";

export class Recipes implements PageableInterface<Recipe> {
    pagination: Pagination;
    docs: Array<Recipe>;

    constructor(dto: {pagination: Pagination, docs: Recipe[]}) {
        this.pagination = dto.pagination;
        this.docs = dto.docs;
    }
}
