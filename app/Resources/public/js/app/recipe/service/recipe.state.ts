import {Injectable} from '@angular/core';
import {Observable} from 'rxjs/Observable';
import {ReplaySubject} from 'rxjs/ReplaySubject';
import {Pageable} from '../../core/model/pageable';
import {PageableState} from '../../shared/model/pageable.state';
import {FilterState} from '../../shared/service/filter.state';
import {Recipe} from '../model/recipe';
import {RecipeDetail} from '../model/recipe-detail';
import {RecipeRepository} from '../repository/recipe.repository';

@Injectable()
export class RecipeState implements PageableState {
    private listPageable = new ReplaySubject<Pageable<Recipe>>(1);

    public constructor(private recipeRepository: RecipeRepository,
                       private filterState: FilterState) {
        this.filterState
            .getFilter()
            .switchMap((params) => this.recipeRepository.getRecipes(params))
            .subscribe(this.listPageable);
    }

    public getPageable(): Observable<Pageable<Recipe>> {
        return this.listPageable.asObservable();
    }

    public getRecipe(recipeId: number): Observable<RecipeDetail> {
        return this.recipeRepository.getRecipe(recipeId).first();
    }
}
