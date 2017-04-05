import {PageableDto} from '../../core/model/dto/pageable.dto';
import {Pagination} from '../../core/model/pagination';
import {RecipeResponseDto} from './dto/recipe-list-response.dto';
import {Recipe} from './recipe';

export class Recipes {
    pagination: Pagination;
    docs: Recipe[];

    constructor(dto: PageableDto<RecipeResponseDto>) {
        this.pagination = dto.pagination;
        this.docs = dto.docs.map((doc: RecipeResponseDto) => new Recipe(doc));
    }
}
