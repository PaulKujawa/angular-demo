import {CookingDto} from './cooking.dto';
import {IngredientDto} from './ingredient.dto';
import {PhotoDto} from './photo.dto';
import {RecipeResponseDto} from './recipe-response.dto';

export interface RecipeDetailDto extends RecipeResponseDto {
    photos: PhotoDto[];
    ingredients: IngredientDto[];
    cookings: CookingDto[];
}