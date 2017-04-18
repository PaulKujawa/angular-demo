import {Injectable} from '@angular/core';
import {Http, URLSearchParams} from '@angular/http';
import {Observable} from 'rxjs/Observable';
import {PageableFactory} from '../../core/factory/pageable.factory';
import {Pageable} from '../../core/model/pageable';
import {RoutingService} from '../../core/service/routing.service';
import {RecipeResponseDto} from '../model/dto/recipe-list-response.dto';
import {Recipe} from '../model/recipe';
import {RecipeDetail} from '../model/recipe-detail';

@Injectable()
export class RecipeRepository {
    constructor(private http: Http,
                private routingService: RoutingService,
                private pageableFactory: PageableFactory) {
    }

    public getRecipes(filter: Map<string, string>): Observable<Pageable<Recipe>> {
        const url = this.routingService.generate('api_get_recipes');
        const queryParameter = new URLSearchParams();

        filter.forEach((value: string, key: string) => queryParameter.set(key, value));

        return this.http.get(url, {search: queryParameter})
            .map((pageableDto) => {
                this.pageableFactory.getPageable<RecipeResponseDto, Recipe>(pageableDto.json(), Recipe);
            })
            .catch((error) => Observable.throw(error.message || error.statusText));
    }

    public getRecipe(id: number): Observable<RecipeDetail> {
        const url = this.routingService.generate('api_get_recipe', {id: id});

        return this.http.get(url)
            .map((recipeDto) => new Recipe(recipeDto.json()))
            .catch((error) => Observable.throw(error.message || error.statusText));
    }
}
