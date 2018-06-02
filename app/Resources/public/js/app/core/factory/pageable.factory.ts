import {Doc} from 'app/core/interface/doc.interface';
import {PageableDto} from 'app/core/model/dto/pageable.dto';
import {Pageable} from 'app/core/model/pageable';
import {Pagination} from 'app/core/model/pagination';

/**
 * usage:
 *  class Recipe implements Doc {};
 *  const dto: PageableDto<RecipeResponseDto> = serverResponse.json();
 *  const recipePageable: Pageable<Recipe> = pageableFactory.getPageable<RecipeResponseDto, Recipe>(dto, Recipe);
 */
export class PageableFactory {
    public getPageable<D, M extends Doc>(dto: PageableDto<D>, M: {new(dto: D): M}): Pageable<M> {
        const pagination = new Pagination(dto.pagination);
        const docs: M[] = dto.docs.map((doc: D) => new M(doc));

        return new Pageable<M>(pagination, docs);
    }
}
