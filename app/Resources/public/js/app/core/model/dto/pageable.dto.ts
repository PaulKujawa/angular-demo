import {PaginationDto} from 'app/core/model/dto/pagination.dto';

export interface PageableDto<T> {
    docs: T[];
    pagination: PaginationDto;
}
