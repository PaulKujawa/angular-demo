import {Injectable} from '@angular/core';
import {Pageable} from 'app/core/model/pageable';
import {Recipe} from 'app/recipe/model/recipe';
import {RecipeDetail} from 'app/recipe/model/recipe-detail';
import {RecipeRepository} from 'app/recipe/repository/recipe.repository';
import {PageableState} from 'app/shared/model/pageable.state';
import {FilterState} from 'app/shared/service/filter.state';
import {Observable, ReplaySubject} from 'rxjs';
import {first, switchMap} from 'rxjs/operators';

@Injectable()
export class RecipeState implements PageableState {
    private listPageable = new ReplaySubject<Pageable<Recipe>>(1);

    public constructor(private recipeRepository: RecipeRepository,
                       private filterState: FilterState) {
        this.filterState.getFilter()
            .pipe(
                switchMap((params) => this.recipeRepository.getRecipes(params)),
            )
            .subscribe(this.listPageable);
    }

    public getPageable(): Observable<Pageable<Recipe>> {
        return this.listPageable.asObservable();
    }

    public getRecipe(recipeId: number): Observable<RecipeDetail> {
        return this.recipeRepository.getRecipe(recipeId)
            .pipe(
                first(),
            );
    }
}
