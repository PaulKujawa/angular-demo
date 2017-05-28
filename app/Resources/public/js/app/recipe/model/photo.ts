import {PhotoDto} from './dto/photo.dto';

export class Photo {
    public id: number;
    public size: number;
    public path: string;
    public created: Date;
    public updated: Date;

    constructor(dto: PhotoDto) {
        this.id = dto.id;
        this.size = dto.size;
        this.path = dto.path;
        this.created = dto.created;
        this.updated = dto.updated;
    }
}
