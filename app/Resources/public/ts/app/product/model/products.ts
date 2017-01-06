import {PageableDto} from '../../core/model/dto/pageable.dto';
import {Pagination} from '../../shared/model/pagination';
import {ProductDto} from './dto/product.dto';
import {Product} from './product';

export class Products {
    pagination: Pagination;
    docs: Product[];

    constructor(dto: PageableDto<ProductDto>) {
        this.pagination = dto.pagination;
        this.docs = dto.docs.map((doc: ProductDto) => new Product(doc));
    }
}
