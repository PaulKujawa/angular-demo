import {Pagination} from '../../shared/model/pagination';
import {RecipeDto} from './dto/recipe.dto';
import {Recipe} from './recipe';
import {PageableDto} from "./dto/pageable.dto";

export class Recipes {
    pagination: Pagination;
    docs: Recipe[];

    constructor(dto: PageableDto<RecipeDto>) {
        this.pagination = dto.pagination;
        this.docs = dto.docs.map((doc: RecipeDto) => new Recipe(doc));
    }
}
