import {CookingDto} from './cooking.dto';
import {IngredientDto} from './ingredient.dto';
import {MacrosDto} from './macros.dto';
import {PhotoDto} from './photo.dto';

export interface RecipeDetailResponseDto {
    id: number;
    name: string;
    isVegan: boolean;
    macros: MacrosDto;
    servings?: number;
    preparationTime?: number;
    created: string;
    updated: string;
    photos: PhotoDto[];
    ingredients: IngredientDto[];
    cookings: CookingDto[];
}
