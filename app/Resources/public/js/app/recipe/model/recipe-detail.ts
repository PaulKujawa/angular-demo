import {Cooking} from './cooking';
import {RecipeDetailResponseDto} from './dto/recipe-detail-response.dto';
import {Ingredient} from './ingredient';
import {Macros} from './macros';
import {Photo} from './photo';

export class RecipeDetail {
    public id: number;
    public name: string;
    public isVegan: boolean;
    public macros: Macros;
    public servings?: number; // TODO mark as required ASAP
    public preratationTime?: number; // TODO mark as required ASAP
    public ingredients: Ingredient[];
    public cookings: Cooking[];
    public photos: Photo[];
    public created: Date;
    public updated: Date;

    constructor(dto: RecipeDetailResponseDto) {
        this.id = dto.id;
        this.name = dto.name;
        this.isVegan = dto.isVegan;
        this.macros = dto.macros;
        this.servings = dto.servings;
        this.preratationTime = dto.preparationTime;
        this.ingredients = dto.ingredients.map((ingredientDto) => new Ingredient(ingredientDto));
        this.cookings = dto.cookings.map((cookingDto) => new Cooking(cookingDto));
        this.photos = dto.photos.map((photoDto) => new Photo(photoDto));
        this.created = new Date(dto.created);
        this.updated = new Date(dto.updated);
    }
}
