import {Injectable} from '@angular/core';
import {Http} from '@angular/http';
import {Observable} from 'rxjs/Observable';
import {PageableFactory} from '../../core/factory/pageable.factory';
import {Pageable} from '../../core/model/pageable';
import {ApiEventHandler} from '../../core/service/api-event.handler';
import {RoutingService} from '../../core/service/routing.service';
import {FilterParameter} from '../../shared/service/filter.service';
import {RecipeResponseDto} from '../model/dto/recipe-list-response.dto';
import {Recipe} from '../model/recipe';
import {RecipeDetail} from '../model/recipe-detail';

@Injectable()
export class RecipeRepository {
    constructor(private http: Http,
                private routingService: RoutingService,
                private apiEventHandlerService: ApiEventHandler,
                private pageableFactory: PageableFactory) {
    }

    public getRecipes(filter: FilterParameter): Observable<Pageable<Recipe>> {
        const url = this.routingService.generate('api_get_recipes');

        return this.http.get(url, {search: filter})
                   .map((pageableDto) => {
                       return this.pageableFactory.getPageable<RecipeResponseDto, Recipe>(pageableDto.json(), Recipe);
                   })
                   .catch((error) => this.apiEventHandlerService.catchError(error));
    }

    public getRecipe(id: number): Observable<RecipeDetail> {
        const url = this.routingService.generate('api_get_recipe', {id: id});

        return this.http.get(url)
                   .map((recipeDto) => new RecipeDetail(recipeDto.json()))
                   .catch((error) => this.apiEventHandlerService.catchError(error));
    }
}
