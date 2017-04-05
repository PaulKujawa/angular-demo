import {PaginationDto} from './pagination.dto';

export interface PageableDto<T> {
    docs: T[];
    pagination: PaginationDto;
}
