import {Injectable} from '@angular/core';
import {Observable} from 'rxjs/Observable';
import {ReplaySubject} from 'rxjs/ReplaySubject';
import {Pageable} from '../../core/model/pageable';
import {FilterState} from '../../shared/service/filter.state';
import {Recipe} from '../model/recipe';
import {RecipeRepository} from '../repository/recipe.repository';
import {PageableState} from '../../shared/model/pageable.state';

@Injectable()
export class RecipeState implements PageableState {
    private pageable = new ReplaySubject<Pageable<Recipe>>(1);

    public constructor(private recipeRepository: RecipeRepository,
                       private filterState: FilterState) {
        this.filterState
            .getFilter()
            .switchMap((params) => this.recipeRepository.getRecipes(params))
            .subscribe(this.pageable);
    }

    public getPageable(): Observable<Pageable<Recipe>> {
        return this.pageable.asObservable();
    }

    public getRecipe(recipeId: number): Observable<Recipe> {
        const cache = this.pageable
            .take(1)
            .filter((pageable) => pageable.hasDoc(recipeId))
            .map((pageable) => pageable.docs[pageable.getIndex(recipeId)]);

        const ajax = this.recipeRepository.getRecipe(recipeId);

        return Observable
            .concat(cache, ajax)
            .first();
    }
}
