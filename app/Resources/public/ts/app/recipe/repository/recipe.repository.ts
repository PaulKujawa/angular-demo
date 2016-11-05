import {Injectable} from "@angular/core";
import {Observable} from "rxjs/Observable";
import {Http, URLSearchParams} from "@angular/http";
import {Recipe} from "../model/recipe";
import {RoutingService} from "../../core/service/routing.service";

@Injectable()
export class RecipeRepository {
    constructor(private http: Http,
                private routingService: RoutingService) {}

    getRecipes(filter: Map<string, string>): Observable<Recipe[]> {
        const url = this.routingService.generate('api_get_recipes');
        const queryParameter = new URLSearchParams();

        filter.forEach((value: string, key: string) => queryParameter.set(key, value));

        return this.http.get(url, {search: queryParameter})
            .map(recipes => recipes.json() || {} )
            .catch(error => Observable.throw(error.message || error.statusText));
    }

    getRecipe(id: number): Observable<Recipe> {
        const url = this.routingService.generate('api_get_recipe', {'id': id});

        return this.http.get(url)
            .map(recipe => recipe.json() || {} )
            .catch(error => Observable.throw(error.message || error.statusText));
    }
}
