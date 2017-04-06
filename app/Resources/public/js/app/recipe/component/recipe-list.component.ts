import {Component, OnInit} from '@angular/core';
import {Router} from '@angular/router';
import {Subject} from 'rxjs/Subject';
import {FlashMessageService} from '../../core/service/flash-message.service';
import {FlashMessage} from '../../core/model/flash-message';
import {Pageable} from '../../core/model/pageable';
import {RecipeRepository} from '../repository/recipe.repository';
import {Recipe} from '../model/recipe';

@Component({
    template: `
        <div class="row">
            <div class="col-xs-12">
                <recipe-filter [pagination]="recipes?.pagination" (filter)="onFilter($event)"></recipe-filter>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="media app-recipes__item" (click)="onSelectRecipe(recipe)" *ngFor="let recipe of pageable?.docs">
                    <div class="media-left app-recipes-item__left">
                        <img class="media-object app-recipes-item__object" [src]="getImageUrl(recipe)"> 
                    </div>
                    <div class="media-body">
                        <h2 class="media-heading">{{recipe.name}}</h2>
                        <macro-chart [macros]="recipe.macros"></macro-chart>
                        <span><i>{{recipe.updated|date}}</i></span>
                    </div>
                </div>
            </div>
        </div>
    `
})
export class RecipeListComponent implements OnInit {
    pageable: Pageable<Recipe>;
    private filterStream = new Subject<Map<string, string>>();

    constructor(private router: Router,
                private flashMsgService: FlashMessageService,
                private recipeRepository: RecipeRepository) {}

    ngOnInit(): void {
        this.filterStream
            .switchMap((queryParams: Map<string, string>) => this.recipeRepository.getRecipes(queryParams))
            .subscribe(
                (pageable: Pageable<Recipe>) => this.pageable = pageable,
                (error: string) => this.flashMsgService.push(new FlashMessage('danger', error))
            );
    }

    onFilter(filterMap: Map<string, string>): void {
        this.filterStream.next(filterMap);
    }

    onSelectRecipe(recipe: Recipe): void {
        const recipeName = recipe.name.replace(' ', '-');
        this.router.navigate(['/recipes', recipe.id, recipeName]);
    }

    getImageUrl(recipe: Recipe): string {
        return recipe.thumbnail
            ? recipe.thumbnail.path
            : 'http://placehold.it/400x300';
    }
}
