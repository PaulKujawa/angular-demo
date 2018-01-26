import {CookingDto} from './cooking.dto';
import {IngredientDto} from './ingredient.dto';
import {PhotoDto} from './photo.dto';
import {RecipeResponseDto} from './recipe-list-response.dto';

export interface RecipeDetailResponseDto extends RecipeResponseDto {
    photos: PhotoDto[];
    ingredients: IngredientDto[];
    cookings: CookingDto[];
}
