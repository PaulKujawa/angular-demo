import {MacrosDto} from 'app/recipe/model/dto/macros.dto';

export interface RecipeDto {
    id: number;
    name: string;
    is_vegan: boolean;
    macros: MacrosDto;
    servings: number;
    preparation_time?: number;
    cook_time?: number;
    photos: string[];
    created: string;
    updated: string;
}
