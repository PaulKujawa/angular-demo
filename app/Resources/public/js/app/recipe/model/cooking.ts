import {CookingDto} from './dto/cooking.dto';

export class Cooking {
    public id: number;
    public position: number;
    public description: string;
    public created: Date;
    public updated: Date;

    constructor(dto: CookingDto) {
        this.id = dto.id;
        this.position = dto.position;
        this.description = dto.description;
        this.created = dto.created;
        this.updated = dto.updated;
    }
}
