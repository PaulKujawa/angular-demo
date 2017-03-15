import {PageableDto} from '../../core/model/dto/pageable.dto';
import {Pagination} from '../../shared/model/pagination';
import {ProductResponseDto} from './dto/product-response.dto';
import {Product} from './product';

export class Products {
    pagination: Pagination;
    docs: Product[];

    constructor(dto: PageableDto<ProductResponseDto>) {
        this.pagination = dto.pagination;
        this.docs = dto.docs.map((doc: ProductResponseDto) => new Product(doc));
    }
}
