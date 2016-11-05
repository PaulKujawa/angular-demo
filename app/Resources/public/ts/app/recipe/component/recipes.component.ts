import {Component, OnInit} from '@angular/core';
import {Router} from "@angular/router";
import {Subject} from "rxjs/Subject";
import {RecipeRepository} from "../repository/recipe.repository";
import {Recipe} from "../model/recipe";
import {FlashMessageService} from "../../core/service/flash-message.service";
import {FlashMessage} from "../../core/model/flash-message";

@Component({
    selector: 'recipes',
    template: `
        <div class="row">
            <div class="col-xs-12 col-sm-3">
                <filter (filter)="onFilter($event)"></filter>
            </div>
            <div class="col-xs-12 col-sm-9">
                <div class="row">
                    <div class="col-xs-12 col-sm-6" *ngFor="let recipe of recipes">
                        <a class="thumbnail" (click)="onSelectRecipe(recipe)">
                            <img [src]="getImageUrl(recipe)"> 
                            <div class="caption">{{ recipe.name }}</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    `
})
export class RecipesComponent implements OnInit {
    recipes: Recipe[];
    private filterStream = new Subject<Map<string, string>>();

    constructor(private router: Router,
                private flashMsgService: FlashMessageService,
                private recipeRepository: RecipeRepository) {}

    ngOnInit(): void {
        this.filterStream
            .switchMap((queryParams: Map<string, string>) => this.recipeRepository.getRecipes(queryParams))
            .subscribe(
                (recipes: Recipe[]) => this.recipes = recipes,
                (error: string) => this.flashMsgService.push(new FlashMessage('danger', error))
            );
    }

    onFilter(filterMap: Map<string, string>): void {
        this.filterStream.next(filterMap);
    }

    onSelectRecipe(recipe: Recipe): void {
        this.router.navigate(['/recipes', recipe.id, recipe.name]); // TODO escape spaces in name
    }

    getImageUrl(recipe: Recipe): string {
        return recipe.thumbnail
            ? recipe.thumbnail.path
            : 'http://placehold.it/400x300';
    }
}
