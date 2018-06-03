import {HttpClient, HttpParams} from '@angular/common/http';
import {Injectable} from '@angular/core';
import {PageableFactory} from 'app/core/factory/pageable.factory';
import {PageableDto} from 'app/core/model/dto/pageable.dto';
import {Pageable} from 'app/core/model/pageable';
import {RoutingService} from 'app/core/service/routing.service';
import {RecipeDetailDto} from 'app/recipe/model/dto/recipe-detail.dto';
import {RecipeDto} from 'app/recipe/model/dto/recipe.dto';
import {Recipe} from 'app/recipe/model/recipe';
import {RecipeDetail} from 'app/recipe/model/recipe-detail';
import {RecipeModule} from 'app/recipe/recipe.module';
import {Observable} from 'rxjs';
import {map} from 'rxjs/operators';

@Injectable({
    providedIn: RecipeModule,
})
export class RecipeRepository {
    constructor(private http: HttpClient,
                private routingService: RoutingService,
                private pageableFactory: PageableFactory) {
    }

    public getRecipes(filter: HttpParams): Observable<Pageable<Recipe>> {
        const url = this.routingService.generate('api_get_recipes');

        return this.http.get<PageableDto<RecipeDto>>(url, {params: filter})
            .pipe(
                map((pageableDto) => this.pageableFactory.getPageable<RecipeDto, Recipe>(pageableDto, Recipe)),
            );
    }

    public getRecipe(id: number): Observable<RecipeDetail> {
        const url = this.routingService.generate('api_get_recipe', {id: id});

        return this.http.get<RecipeDetailDto>(url)
            .pipe(
                map((recipeDto) => new RecipeDetail(recipeDto)),
            );
    }
}
