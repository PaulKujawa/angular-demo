import {Injectable} from '@angular/core';
import {PageableDto} from '../model/dto/pageable.dto';
import {Pageable} from '../model/pageable';

/**
 * usage:
 *  const dto: PageableDto<RecipeResponseDto> = <any>{};
 *  const recipePageable: Pageable<Recipe> = pageableFactory.getPageable<RecipeResponseDto, Recipe>(dto, Recipe);
 */

@Injectable()
export class PageableFactory {
    public getPageable<D, M>(dto: PageableDto<D>, M: {new(dto: D): M}): Pageable<M> {
        const pagination = dto.pagination;
        const docs = dto.docs.map((doc: D) => new M(doc));

        return new Pageable<M>(pagination, docs);
    }
}
