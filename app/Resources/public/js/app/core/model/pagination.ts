import {PaginationDto} from 'app/core/model/dto/pagination.dto';

export class Pagination {
    public page: number;
    public pages: number;
    public pageSize: number;
    public numFound: number;

    constructor(dto: PaginationDto) {
        this.page = dto.page;
        this.pages = dto.pages;
        this.pageSize = dto.page_size;
        this.numFound = dto.pages * dto.page_size; // TODO dto.num_found;
    }
}
