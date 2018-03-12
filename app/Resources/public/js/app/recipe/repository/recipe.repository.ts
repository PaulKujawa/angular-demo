import {HttpClient, HttpParams} from '@angular/common/http';
import {Injectable} from '@angular/core';
import {Observable} from 'rxjs/Observable';
import {PageableFactory} from '../../core/factory/pageable.factory';
import {PageableDto} from '../../core/model/dto/pageable.dto';
import {Pageable} from '../../core/model/pageable';
import {RoutingService} from '../../core/service/routing.service';
import {RecipeDetailDto} from '../model/dto/recipe-detail.dto';
import {RecipeDto} from '../model/dto/recipe.dto';
import {Recipe} from '../model/recipe';
import {RecipeDetail} from '../model/recipe-detail';

@Injectable()
export class RecipeRepository {
    constructor(private http: HttpClient,
                private routingService: RoutingService,
                private pageableFactory: PageableFactory) {
    }

    public getRecipes(filter: HttpParams): Observable<Pageable<Recipe>> {
        const url = this.routingService.generate('api_get_recipes');

        return this.http
            .get<PageableDto<RecipeDto>>(url, {params: filter})
            .map((pageableDto) => this.pageableFactory.getPageable<RecipeDto, Recipe>(pageableDto, Recipe));
    }

    public getRecipe(id: number): Observable<RecipeDetail> {
        const url = this.routingService.generate('api_get_recipe', {id: id});

        return this.http
            .get<RecipeDetailDto>(url)
            .map((recipeDto) => new RecipeDetail(recipeDto));
    }
}
