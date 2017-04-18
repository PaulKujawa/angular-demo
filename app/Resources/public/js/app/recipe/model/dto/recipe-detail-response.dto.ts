import {Cooking} from '../cooking';
import {Ingredient} from '../ingredient';
import {Photo} from '../photo';
import {RecipeResponseDto} from './recipe-list-response.dto';

export interface RecipeDetailResponseDto extends RecipeResponseDto {
    photos: Photo;
    ingredients: Ingredient[];
    cookings: Cooking[];
}
