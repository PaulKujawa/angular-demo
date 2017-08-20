import {PageableDto} from '../model/dto/pageable.dto';
import {Doc, Pageable} from '../model/pageable';

/**
 * usage:
 *  class Recipe implements Doc {};
 *  const dto: PageableDto<RecipeResponseDto> = serverResponse.json();
 *  const recipePageable: Pageable<Recipe> = pageableFactory.getPageable<RecipeResponseDto, Recipe>(dto, Recipe);
 */
export class PageableFactory {
    public getPageable<D, M extends Doc>(dto: PageableDto<D>, M: {new(dto: D): M}): Pageable<M> {
        const pagination = dto.pagination;
        const docs: M[] = dto.docs.map((doc: D) => new M(doc));

        return new Pageable<M>(pagination, docs);
    }
}
